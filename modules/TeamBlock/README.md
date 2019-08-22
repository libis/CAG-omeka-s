# Simple Block

An example Omeka S module that creates  a (very) simple block layout.

## File Layout

As a simple module, there's not much beyond the bare minimum of files:

- Module.php: Necessary for all modules. In this simple example, just points to the module config.
- config/module.ini: Necessary for all modules. Defines simple module data like name, author, and
  links for users to get help or report problems.
- config/config.module.php: One of the most important single files in most modules. Settings here
  can add to or override settings and features from most of the core and even other modules. In
  this simple example, the module config file is used to add our custom block layout to the list
  of available layouts.
- src/Site/BlockLayout/SimpleBlock.php: The actual block layout. The directory path for this file
  is chosen to parallel where block layouts are stored in the Omeka S core. While this isn't
  required, it's a best practice so it's clearer where things are.

