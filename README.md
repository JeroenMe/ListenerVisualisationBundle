ListenerVisualisationBundle
===========================
## Install

 add following lines to composer.json
 ```
   "repositories": [
        {
            "type": "git",
            "url": "git@github.com:JeroenMe/ListenerVisualisationBundle"
        }
   ]
 ```

 ```
  "require": {
     "jeroenme/listenervisualisation-bundle": "*"
  },
 ```

 run composer update jeroenme/listenervisualisation-bundle

 add following to AppKernel.php
 ```
 new JeroenMe\Bundle\ListenerVisualisationBundle\ListenerVisualisationBundle()
 ```
 
## Usage
 List all listeners 'app/console listeners:list'
 
 List listeners for specific event 'app/console listeners:list eventname'
