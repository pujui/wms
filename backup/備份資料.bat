@echo off
set x=%date:~0,4%%date:~5,2%%date:~8,2%

C:/xampp/mysql/bin/mysqldump --user=root wms > wms-%x%.sql

pause