# NeopBlog RSS Generator — Foresee #

**NeopBlog** is a static blog CMS developed by **Joy Neop**. It doesn’t have RSS therefore an external RSS generator is needed.

## Preview ##

This generator is written in PHP. And MySQL is needed.

## Fetching ##

Set an cron job which make this generator fetch posts every 15 minutes. It will fetch `meta.json` and check if the value of key `totalPosts` is increased, and will fetch `list.json` to index the blog.

For example, you have 42 posts initially, when you update your `meta.json`, this generator will know that you have a new post and will calculate how many posts are new to be fetched.

After last fetching, if you added 3 posts, the value of key `totalPosts` in `meta.json` should be `45`. In this generator’s database, the previous number is 42, so it knows that there are 3 posts new.

Then in a looping, this generator will fetch `db/42.txt`, `db/43.txt` and `db/44.txt`. And the post title and post date included in `list.json` is associated.

## Saving ##

By the time new posts are got, they will be stored in the database, a table which contains columns `ID`, `Date`, `Title` and `Text`.

## Showing ##

When the url `index.php?blog=www.joyneop.com` is 	being requested, `index.php` will fetch data from database and and expose the posts as RSS format.