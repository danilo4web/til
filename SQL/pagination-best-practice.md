$page_number = 5
$rows_per_page = 20

SELECT 
	ID_EXAMPLE, 
	NM_EXAMPLE, 
	DT_CREATE
FROM 
	TB_EXAMPLE
OFFSET 
	((‘.$page_number.’ - 1) * ‘ . $rows_per_page . ’) ROWS
FETCH 
	NEXT ‘ . $rows_per_page . ’ ROWS ONLY;