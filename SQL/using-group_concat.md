## Example - Using Group Concat

SELECT 
	G.descricao, 
    	(SELECT
		GROUP_CONCAT(emissora.descricao SEPARATOR ', ')
	FROM
   		grade_item
		INNER JOIN emissora ON (emissora.id = grade_item.fk_emissora)
   	WHERE
		grade_item.fk_grade = G.id
   	GROUP BY
   		grade_item.fk_grade) as programacao
FROM
	grade G;
