@echo off
set x=%date:~8,2%
set /p var="please input 2%x% : ":

set /a ans="2%x%"

IF %var% EQU %ans% (C:/xampp/mysql/bin/mysql --user=root -p < system/create_db.sql)

pause


