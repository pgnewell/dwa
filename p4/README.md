Active Cookbook

The idea behind this is to be able to build a recipe in such a way that it can be "replayed". That is, it should be able to be put on a tablet and used as a cookbook where the cook could check off the things he has done and be presented with those that can be done next when they can be done. 

This is much more complicated than I think can be done here and the details would be difficult to go into but I just wanted to prototype a system that showed some minimal functionality along those lines.

So I thought if you could simply add a text box describing a step that the user could fill with instructions and then he/she could subsequently connect that instruction to a previous instruction so it would not be displayed until the first was done. In reality the relation between steps is more complex but this is a start.

At this time there are several problems. 

I promised edit and photos. photos should be easy, but alas. Nothing else was.

The dependencies can be confusing. It should be able to show what dependencies there are. This is really crucial but I am not sure how to accomplish it without more sophisticated JS than I have at my displosal. As it is youj can really only give one dependency to a step, which makes some sense but I am not sure it is ideal. I orivinally intended that they be drag and drop and this is not as hard as I thought but I am too tired to do it. You can probably make a circular dependency.

Using ajax proved to be very difficult. The POSTs were reinterpreted by the server and the quotes in ajax data were escaped for a security reason. This took me way too long to discover. You need to strip them in order to parse the json.

It is slow. There are too many .lives in the JS. This could be easily remedied by removing the buttons from the display and putting them in the edit.

No ordering in the recipe display.

The textareas in the steps need to be auto sizing.

The information area needs to be more dynamic.
