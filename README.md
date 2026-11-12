# Fring

A low complexity self-hosted webring.
Fully customizable with default style options.
Navigation / forwarding is handled by the Fring server so continuity is always maintained.
The embed for members is a few lines of HTML and a CSS file.

# How to Set Up

1. Rename "members.example.php" to "members.php".

Set your ring's name at the top of the "members.php" file: `$title = 'My Ring';`

Optional: add copy to the directory page by editing `$intro` in members.php. It accepts plain HTML.

Add all members of web ring. Use lowercase letters, numbers and hyphens, with at least one letter.
They will need a unique ID, a display name and a URL:

'robin' => ['name' => 'Robin', 'url' => 'https://example.com/'],

This is the core list of directory members for both the directory and the arrow links, and it must be maintained manually. 

Add a 128×128 PNG or JPG to the `members` folder, named after the member, such as
`members/robin.jpg`. Non-square images are cropped to fit. Members without one show an empty box.

Style the directory and embed by editing the PHP + CSS files.
The member directory (index.php) has an external CSS file (dir.css) and the webring
embed has its own (ring.css) to provide a default embed style for your members. 

2. Upload contents of the fring folder to the root of a domain/subdomain for your webring directory.

3. Have ring members paste this HTML anywhere on their page.
Replace fring.yourdomain.com with your address and membername with that member’s ID from members.php.

<link rel="stylesheet" href="https://fring.yourdomain.com/ring.css">
<nav class="ring" aria-label="Fring webring">
  <a class="prev" href="https://fring.yourdomain.com/?id=membername&amp;go=prev">
    <img src="https://fring.yourdomain.com/img/arrow.svg" alt="Previous site">
  </a>
  <a class="dir" href="https://fring.yourdomain.com/">
    <img src="https://fring.yourdomain.com/img/dir.png" alt="Directory">
  </a>
  <a class="next" href="https://fring.yourdomain.com/?id=membername&amp;go=next">
    <img src="https://fring.yourdomain.com/img/arrow.svg" alt="Next site">
  </a>
</nav>

# Styling

To customize the member-side embed, edit the values in an inline style
block between the CSS link and the html for the embed block.

CSS variable code example:
<style>
.ring {
  --ring-bg: #999999; // the embed back block background color 
  --ring-border: 10px solid #50f; // an HTML border around the embed, make it 0 for no border
  --ring-height: 40px; // embed height
  --ring-pad: 12px; // inner padding of the embed block
}
.ring a {
  transition: scale .15s; // the new embed hover animation, more examples below
}
.ring a:hover,
.ring a:focus-visible {
  opacity: 1; // resets the default opacity hover
  scale: 1.1; // the new scale hover animation
}
</style>

The hover for the embed can be reset by adding opacity:1; and can be modified to any of the following CSS animations:
Grow / example: scale: 1.25;
Move / example: translate: 0 -2px;
Rotate / example: rotate: 10deg;
Colour / example: filter: invert(1);

The embed's logo is pulled from the Fring server by default but can overridden by changing the URL to a local file.
A best practice is to have a version of your default logo in both black and white for dark and light embeds.

The same is true for the nav arrows. Use a roughly square-ish image of a right-pointing arrow with a transparent background. It's mirrored for both sides.