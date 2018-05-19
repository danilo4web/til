select 
	fullname, count(*) 
from 
	users 
where 
	status = 1 
group by 
	fullname 
having 
	count(*) > 1;