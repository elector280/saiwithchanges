<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MediaFile;
use App\Models\MediaFolder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        $folderId = $request->integer('folder_id');
        $folder = $folderId ? MediaFolder::findOrFail($folderId) : null;

        $folders = MediaFolder::query()
            ->where('parent_id', $folderId ?: null)
            ->orderBy('name')
            ->get();

        $files = MediaFile::query()
            ->where('folder_id', $folderId ?: null)
            ->orderByDesc('id')
            ->get();

        // breadcrumbs
        $breadcrumbs = [];
        $cur = $folder;
        while ($cur) {
            $breadcrumbs[] = $cur;
            $cur = $cur->parent_id ? MediaFolder::find($cur->parent_id) : null;
        }
        $breadcrumbs = array_reverse($breadcrumbs);

        // destinations for move dropdown
        $allFolders = MediaFolder::orderBy('name')->get();

        return view('admin.media.index', compact('folderId','folder','folders','files','breadcrumbs','allFolders'));
    }

    public function createFolder(Request $request)
    {
        // 0 হলে null করে দিচ্ছি (root)
        $request->merge([
            'parent_id' => ($request->input('parent_id') == 0) ? null : $request->input('parent_id')
        ]);

        $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:media_folders,id'],
            'name' => ['required', 'string', 'max:150'],
        ]);

        $slug = Str::slug($request->name) ?: Str::random(8);

        $base = $slug;
        $i = 1;
        while (MediaFolder::where('parent_id', $request->parent_id)->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        MediaFolder::create([
            'parent_id' => $request->parent_id, // এখন null বা valid id
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return back()->with('success', 'Folder created successfully.');
    }


    public function upload(Request $request)
    {
        // 0 হলে root হিসেবে null ধরে নাও
        $request->merge([
            'folder_id' => ($request->input('folder_id') == 0) ? null : $request->input('folder_id'),
        ]);

        $request->validate([
            'folder_id' => ['nullable','integer','exists:media_folders,id'],
            'files' => ['required','array','min:1'],
            'files.*' => ['file','max:20480'], // 20MB
        ]);

       $disk = 'public';
$stored = [];

if ($request->hasFile('files')) {

    foreach ($request->file('files') as $file) {

        // 📁 Path (same style as top code but custom folder)
        $path = 'gallery_image/' . date('Y') . '/' . date('m');

        // 📝 Filename
        $filename = time() . '_gallery_' . Str::random(6) . '.' . $file->getClientOriginalExtension();

        // 💾 Store file
        Storage::disk($disk)->putFileAs($path, $file, $filename);

        $fullPath = $path . '/' . $filename;

        // 📦 File meta
        $mime = $file->getMimeType();
        $size = $file->getSize();

        // 🖼 Image dimension
        $width = null;
        $height = null;

        if (str_starts_with((string) $mime, 'image/') && function_exists('getimagesize')) {
            try {
                [$width, $height] = @getimagesize($file->getRealPath()) ?: [null, null];
            } catch (\Throwable $e) {
                $width = $height = null;
            }
        }

        // 🗄 Save DB
        $stored[] = MediaFile::create([
            'folder_id'      => $request->folder_id,
            'disk'           => $disk,
            'path'           => $fullPath,
            'original_name'  => $file->getClientOriginalName(),
            'mime_type'      => $mime,
            'size'           => $size,
            'width'          => $width,
            'height'         => $height,
        ]);
    }
}

        return response()->json([
            'ok' => true,
            'count' => count($stored),
            'items' => $stored,
        ]);
    }


    public function show(string $type, int $id)
{
    if ($type === 'file') {
        $file = MediaFile::findOrFail($id);

        return response()->json([
            'type' => 'file',
            'id' => $file->id,
            'title' => $file->original_name,
            'mime' => $file->mime_type,
            'size' => (int) $file->size,
            'path' => $file->path,          // ✅ MUST
            'disk' => $file->disk,
            'updated_at' => optional($file->updated_at)->toDateTimeString(),
        ]);
    }

    if ($type === 'folder') {
        $folder = MediaFolder::findOrFail($id);

        return response()->json([
            'type' => 'folder',
            'id' => $folder->id,
            'title' => $folder->name,
            'updated_at' => optional($folder->updated_at)->toDateTimeString(),
        ]);
    }

    abort(404);
}


    public function move(Request $request)
    {
        $request->validate([
            'type' => ['required','in:file,folder'],
            'id' => ['required','integer'],
            'target_folder_id' => ['nullable','integer','exists:media_folders,id'],
        ]);

        if ($request->type === 'file') {
            $file = MediaFile::findOrFail($request->id);
            $file->update(['folder_id' => $request->target_folder_id]);
        } else {
            $folder = MediaFolder::findOrFail($request->id);
            // avoid moving into itself
            if ($request->target_folder_id && $request->target_folder_id === $folder->id) {
                return response()->json(['ok' => false, 'message' => 'Invalid destination.'], 422);
            }
            $folder->update(['parent_id' => $request->target_folder_id]);
        }

        return response()->json(['ok' => true]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'type' => ['required','in:file,folder'],
            'id' => ['required','integer'],
        ]);

        if ($request->type === 'file') {
            $file = MediaFile::findOrFail($request->id);
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        } else {
            $folder = MediaFolder::findOrFail($request->id);

            // simple safe rule: allow delete only if empty
            $hasChildren = MediaFolder::where('parent_id', $folder->id)->exists();
            $hasFiles = MediaFile::where('folder_id', $folder->id)->exists();
            if ($hasChildren || $hasFiles) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Folder is not empty. Delete items first.'
                ], 422);
            }
            $folder->delete();
        }

        return response()->json(['ok' => true]);
    }
}
