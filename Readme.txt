# SCSS

Follows BEM naming rules
Sass is compiled locally into usable CSS to be later uploaded to php server.

## Tools

Live watch sass vscode extension

### NPM
bootstrap
boostrap icons
Sass

## Instructions

1. config setting of live watch to compile to css folder
2. create folder structure of sass
3. link the min.map.css in header.
4. use custom.scss to modify vars and add new styles

##SASS and Bootstrap

- utilized utility api to extend and modify utility classes. 
- created custom variables
- have some custom css as-well
- utilized various bootstrap mixins

##Vertical-rhythm

Feature a baseline with vertical rhythm and responsive type.

Spacing is a modified bootstrap map to match baseline spacing so p-1 m-1 etc. are increments of baseline.

typographic scale of 1.25 major third.




#PHP

##IMAGES

PROBLEM: images must have apsect ratio to fit cards and work with css
SOLUTION: crop and resize in php --or-- limit image uploads to be 1:1 square images.

1. makes an original image and creates a thumbnail that is cropped to fit cards on front page.
2. thumbnail  calculates height and then crops image with black bars at the top and bottom. Making sure the aspect ratio in kept to fit list cards.

TODO: 

Dream Host Issues

3. need to add htaccess file.

4. re-format readme

11. remove debug code and sanitize pagination stuff

13. run through html validation and best seo practices

15. logout timer



SESSION DEBUG - FIXED no code must be above very first PHP tag at top of file !!!





---Vertical rhythm---



https://iamsteve.me/blog/a-guide-to-vertical-rhythm
FLUID doesnt work well with vertical rhythm. Decide between fluid or responsive design
if RESPONSIVE use break points to change font size and DO NOT use clamp(), or change line height with function ?
imgs need to work with responsive break points. not fluid.
THIS PROJECT KEPT FLUID. To much work to redesign into fluid. Especially with bootstrap

1. choose font family DONE
2. set default font-size DONE 16px
3. 24px baseline grid

