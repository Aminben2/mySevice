var currentURL = window.location.href;
// Get the list of header links
var headerLinks = document.getElementById("header-links").getElementsByTagName("a");

// Iterate over each link and compare its URL with the current page URL
for (var i = 0; i < headerLinks.length; i++) {
    var link = headerLinks[i];
    var linkURL = link.href;

    // Check if the link URL matches the current page URL
    if (linkURL === currentURL) {
        // Apply the active class to the link's parent list item
        link.parentNode.classList.add("active")
    }
}