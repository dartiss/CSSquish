# CSS Compressor

🗜️ PHP script to compress CSS

Initial written a long time ago, this is a private script for ad-hoc CSS compression which I'm turning into a modern, fully featured version.

Expect further notes and content to be uploaded over the coming months.

If you have any thoughts on good compression techniques, please let me know in the issues.

## Instructions for use

The script function is named `compress_css` and has just one parameter - the CSS script that you wish to compress.

It returns an array containing 4 elements...

1. `output` - the compressed CSS
2. `before` - how many bytes the CSS was initially
3. `after` - how many bytes the CSS was after compression
4. `percent` - the percentage size improvement due to compression