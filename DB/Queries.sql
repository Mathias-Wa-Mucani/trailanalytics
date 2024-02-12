--Most preferred movie
select p.PreferredMovie, count(p.PreferredMovie) counter  from preferredmovies p group by p.PreferredMovie order by count(p.PreferredMovie) desc limit 1  
--------------------------------

---Least preferred movie type
select p.TypeOfMovie , count(p.TypeOfMovie) counter  from preferredmovies p group by p.TypeOfMovie  order by count(p.TypeOfMovie) asc limit 1  
-------------------------------------------------

-----Top 2 popular movie types by family members older than 10 years
select p.TypeOfMovie , count(p.TypeOfMovie) counter, f.FirstName , ceiling (datediff(curdate(),f.DateOfBirth) / 365) age from preferredmovies p 
inner join familymembers f on f.id = p.userID 
 where ceiling (datediff(curdate(),f.DateOfBirth) / 365) > 10
group by  p.TypeOfMovie   order by count(p.TypeOfMovie) desc  limit 2
-----------------------------------------------------------------------------

---- Top 2 popular movie types by female family members
select p.TypeOfMovie , count(p.TypeOfMovie) counter, f.FirstName , ceiling (datediff(curdate(),f.DateOfBirth) / 365) age from preferredmovies p 
inner join familymembers f on f.id = p.userID 
 where f.Gender = 'Female'
group by  p.TypeOfMovie   order by count(p.TypeOfMovie) desc  limit 2
-------------------------------------------------------------------------

-- Family members with no preferred movies 
select f.* from familymembers f where f.id not in (select p.userID from preferredmovies p)
-------------------------------------------------
