# Map Markers

This OctoberCMS plugin allows user to set up and display multiple markers on Google Map.

Aside coordinates, each marker can have a title, attached image and optional links to other content.
At the moment, links to blog posts from [RainLab.Blog](https://octobercms.com/plugin/rainlab-blog) and albums from [Graker.PhotoAlbums](https://github.com/graker/photoalbums) are supported.

## Usage

Don't forget to set Google API key on the plugin's Settings page.

### Map component

To use the plugin, install it as usual, go to graker/mapmarkers at Backend, create some markers and optionally link them to blog posts and photo albums.
Then add Map component to a page. The map will be displayed with all the markers you created.
For this component, you can set:

* latitude and longitude for default map center
* default map zoom
* custom map marker icon (full path to file)
* post and album pages (needed if you want to attach posts and albums to markers)

Attaching posts and albums to markers is totally optional. If you have no need for it, you still can create markers with a title, image and description.

After setting up a component, look at partials at `components/map` in plugin directory. 
As you can see, beside `default.htm` (map container markup), there is `popup.htm` partial. 
It is used to render popups when markers on the map are being clicked. Override this partial's markup for your needs.

### Markers List component

This component can be used to display markers as plain content (like posts), for example, under the map. 
For each marker you can display a title, image thumbnail, description and links to attached blog posts and photo albums. 

### Single Url feature

If a marker has exactly one other model attached (either post or album), `marker.singleUrl` value will be available both in Map and Markers List component partials. It will contain a string with url to this single attachment. You can use it to link to this attachment from marker's thumbnail and title. An example usage is in component partials.

If there are more than one models attached (or none at all), `marker.singleUrl` value will be an empty string.

### Thumbnail feature

Markers displayed in both Map and Markers List components can have image thumbnails. You can set up thumbnail width, height and resizing mode in component's parameters. Thumbnail will be available in component partials (`marker.thumb` value).

Marker's thumbnail is automatically generated from any image available in following priority:

1. If there is image directly attached to the marker, it will be used as a thumbnail.
2. If there are posts attached to the marker, the first available featured image from any post will be used as a thumbnail.
3. If there are albums attached, the latest photo from the first album will be used.

## Roadmap

Current roadmap is to:
 
* do some refactoring to similar component methods like loadMarkers
* add sprites support for markers
* move map component styles to CSS assets
