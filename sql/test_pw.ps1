$exe = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe"
$passwords = @("", "root", "admin", "password", "123456", "root123", "toor", "mysql", "Admin@123", "Root@123")
foreach ($p in $passwords) {
    $arg = "--password=" + $p
    $res = & $exe -u root $arg -e "SELECT 1;" 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "MATCH_FOUND:$p"
        exit 0
    }
}
Write-Host "NO_MATCH_FOUND"
