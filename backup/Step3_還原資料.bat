@echo off
set x=%date:~8,2%
set /p var="please input 3%x% : ":

set /a ans="3%x%"

IF %var% EQU %ans% (C:/xampp/mysql/bin/mysql --user=root -p wms < wms.sql)

pause

