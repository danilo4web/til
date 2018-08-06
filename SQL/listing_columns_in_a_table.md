
# listing all the tables in a database:
select * from information_schema.TABLES where TABLE_SCHEMA = 'juridico';

# or also:
SHOW TABLES FROM juridico;



# listing all the columns in a table:
select * from COLUMNS where TABLE_SCHEMA = 'juridico' and TABLE_NAME = 'contrato';

# or also:
SHOW COLUMNS FROM contrato FROM juridico;