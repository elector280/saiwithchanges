$excel = New-Object -ComObject Excel.Application
$excel.Visible = $false
$excel.DisplayAlerts = $false
$wb = $excel.Workbooks.Open("C:\Users\MalcaCorp\Desktop\proyecto\public_html\issues_overview_report.xls")
$ws = $wb.Sheets.Item(1)
$ws.SaveAs("C:\Users\MalcaCorp\Desktop\proyecto\public_html\issues_overview_report.csv", 6)
$wb.Close($false)
$excel.Quit()
Write-Host "Conversion complete"
