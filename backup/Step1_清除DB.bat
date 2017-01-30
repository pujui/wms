@echo off
set x=%date:~8,2%
set /p var="please input 1%x% : ":

set /a ans="1%x%"

IF %var% EQU %ans% (C:/xampp/mysql/bin/mysql --user=root -p < system/drop_db.sql)

pause


