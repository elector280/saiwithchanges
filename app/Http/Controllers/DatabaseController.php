<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseController extends Controller
{
    // ✅ change it if you want to protect important tables from delete
    private array $protectedTables = [
        'migrations',
        'password_reset_tokens',
        'failed_jobs',
        'personal_access_tokens',
        // 'users',
    ];

    public function index()
    {
        $dbName = DB::getDatabaseName();

        // MySQL / MariaDB: SHOW TABLES
        $rows = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $dbName;

        $tables = collect($rows)
            ->map(fn($r) => $r->{$key} ?? null)
            ->filter()
            ->values();

        return view('admin.database.index', compact('tables'));
    }

    public function show(string $table)
    {
        $this->assertValidTable($table);

        if (!Schema::hasTable($table)) {
            return response()->json(['ok' => false, 'message' => 'Table not found.'], 404);
        }

        $dbName = DB::getDatabaseName();

        $columns = DB::table('information_schema.COLUMNS')
            ->select([
                'COLUMN_NAME as field',
                'COLUMN_TYPE as type',
                'IS_NULLABLE as is_nullable',
                'COLUMN_KEY as col_key',
                'COLUMN_DEFAULT as col_default',
                'EXTRA as extra',
            ])
            ->where('TABLE_SCHEMA', $dbName)
            ->where('TABLE_NAME', $table)
            ->orderBy('ORDINAL_POSITION')
            ->get();

        return response()->json([
            'ok' => true,
            'table' => $table,
            'columns' => $columns,
        ]);
    }

    public function destroy(Request $request, string $table)
    {
        $this->assertValidTable($table);

        if (in_array($table, $this->protectedTables, true)) {
            return back()->with('success', "You can't delete protected table: {$table}");
        }

        if (!Schema::hasTable($table)) {
            return back()->with('success', "Table not found: {$table}");
        }

        Schema::drop($table);

        return back()->with('success', "Table deleted successfully: {$table}");
    }

    private function assertValidTable(string $table): void
    {
        // strict allow only: a-z A-Z 0-9 _
        if (!preg_match('/^[A-Za-z0-9_]+$/', $table)) {
            abort(400, 'Invalid table name.');
        }
    }



public function breadindex()
{
    $dbName = DB::getDatabaseName();
    $rows = DB::select('SHOW TABLES');
    $key  = 'Tables_in_' . $dbName;

    $tables = collect($rows)
        ->map(fn($r) => $r->{$key} ?? null)
        ->filter()
        ->values();

    // ✅ BREAD table list
    $breadTables = collect([
        'roles', 'users', 'permissions',
        'sliders', 'sponsors', 'reviews',
        'campaigns', 'stories', 'categories',
    ])->filter(fn($t) => Schema::hasTable($t))->values()->all();

    // ✅ table => browse route name (this is the fix)
    $breadRoutes = [
        'roles'       => 'roles.index',
        'users'       => 'users.index',
        'permissions' => 'permissions.index',

        'sliders'     => 'sliders.index',      // Route::resource('admin/sliders'...) নাম sliders.index
        'sponsors'    => 'sponsors.index',
        'reviews'     => 'reviews.index',

        'campaigns'   => 'campaigns.index',    // Route::resource('admin/campaigns'...)
        'stories'     => 'stories.index',

        'categories'  => 'categories.index',   // admin prefix resource('categories'...) -> categories.index
    ];

    return view('admin.database.bread', compact('tables', 'breadTables', 'breadRoutes'));
}



}
