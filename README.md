# CSS Compressor

🗜️ PHP script to compress CSS

Initially written many years ago and hosted as an online tool on my websute, this is a script for ad-hoc CSS compression which I'm turning into a modern, fully featured version. It's GPL licensed, so feel free to copy, clone, do whatever you wish with it.

Expect further notes and content to be uploaded over the coming months.

If you have any thoughts on good compression techniques, please let me know in the issues.

## Instructions for use

The script function is named `compress_css` and has just one parameter - the CSS script that you wish to compress.

It returns an array containing 4 elements...

1. `output` - the compressed CSS
2. `before` - how many bytes the CSS was initially
3. `after` - how many bytes the CSS was after compression
4. `percent` - the percentage size improvement due to compression