# fromton

## How to add an image
The images are manage by webpack

 - You'll have to put it in a folder in `assets/images`

 - Then in `app.js` in the section *Images* add : `require('../images/[path-to-image]/image.[ext]')`

 - And ofc run webpack. 
 
 - You'll be able to use it like `<img src="{{ asset('build/images/[path-to-image]/image.[ext]) }}" alt="mouse">`
