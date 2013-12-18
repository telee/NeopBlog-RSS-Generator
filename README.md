# NeopBlog RSS Generator — Foresee #

**NeopBlog** is a static blog CMS developed by **Joy Neop**. It doesn’t have RSS therefore an external RSS generator is needed. http://blog.joyneop.com/

## Fetching ##

This generator fetches the latest posts, at most 50 posts once. Because it doesn’t have database to cache, instead, it fetches posts by the time the generator is queried.

This generator will get the `meta.json` of the blog and find out how many posts does the blog have. And will list out the latest 50 posts if the value of key `totalPosts` is greater than 50.

## Showing ##

When the url `index.php?blog=www.joyneop.com` is 	being requested, `index.php` will fetch data from database and and expose the posts in RSS format.