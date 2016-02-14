# Map Markers

This OctoberCMS plugin allows user to set up and display multiple markers on Google Map.

Aside coordinates, each marker can have a title, attached image and optional links to other content.
Links to blog posts from RainLab.Blog and albums from Graker.PhotoAlbums are supported.

At the moment following basic functionality is working:
 - adding markers
 - setting marker coordinates by clicking on the map
 - attaching images, blog posts and photo albums to markers
 - markers list and map with markers in the backend
 - map component to output map with markers in the frontend
 - displaying popup (info windows) when a marker is clicked

Current roadmap is:
 - to create a widget more complex to add references (posts and albums) since checkboxes from relation widget won't be enough when having 1000+ of posts
 - to move map component styles to CSS assets rather than having them in partials
 - to add more map component settings like the map center and zoom
 - to add the ability to use Google API key if it exists
 - to create a form widget to enter latitude and longitude more elegantly (see the formwidget branch)
