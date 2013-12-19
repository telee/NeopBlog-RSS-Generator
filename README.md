# NeopBlog RSS Generator — Foresee #

**NeopBlog** is a static blog CMS developed by **Joy Neop**. It doesn’t have RSS therefore an external RSS generator is needed. http://blog.joyneop.com/

## How To Use ##

If your blog is `http://blog.joyneop.com/`, your RSS feed URL is `http://app.joyneop.com/nb-rss/?domain=blog.joyneop.com`.

If you blog is `http://www.joyneop.com/blog/`, in other words you are using subdirectory, your RSS feed URL is `http://app.joyneop.com/nb-rss/?domain=www.joyneop.com&dir=blog`.

Currently this generator is still under construction so the instruction above is not usable. If you try now you will see a list of posts output in HTML with original style, instead of RSS.

## How It Works ##

### Fetching ###

This generator fetches the latest posts, at most 50 posts once. Because it doesn’t have database to cache, instead, it fetches posts by the time the generator is queried.

This generator will get the `meta.json` of the blog and find out how many posts does the blog have. And will list out the latest 50 posts if the value of key `totalPosts` is greater than 50.

### Showing ###

When the url `index.php?blog=www.joyneop.com` is 	being requested, `index.php` will fetch data from database and and expose the posts in RSS format.

## License ##

This program is private but will be released with *CC BY-NC-SA 4.0* license after completion.

## Credits ##

* 朱焕杰