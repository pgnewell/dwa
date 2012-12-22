Active Cookbook

The idea behind this is to be able to build a recipe in such a way that it can be "replayed". That is, it should be able to be put on a tablet and used as a cookbook where the cook could check off the things he has done and be presented with those that can be done next when they can be done. 

This is much more complicated than I think can be done here and the details would be difficult to go into but I just wanted to prototype a system that showed some minimal functionality along those lines.

So I thought if you could simply add a text box describing a step that the user could fill with instructions and then he/she could subsequently connect that instruction to a previous instruction so it would not be displayed until the first was done. In reality the relation between steps is more complex but this is a start.

At this time there are several problems. 

I promised edit and photos. I almost got edit but no. photos should be easy, but alas. Nothing else was.

The dependencies go into the database correctly but they dont get used properly. The execution window doesnt seem to get them.

To add to all this something on the server isnt working at all. Apparently the mechanism I use to load screens from php via ajax is failing. I am debugging.
