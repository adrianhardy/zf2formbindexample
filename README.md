zf2formbindexample
==================

This started out as a worked example on getting form binding to work in ZF2. 
My initial goal was very simple - have two related objects (Person and Address)
show up on the form. 

The problem then came about as to how to have the fieldsets work with hydrators
and my entities. My current understanding is that in order to have an address 
fieldset (for example) automagically populate, your base object (Person, in 
this case) must have a getAddress() object which can then by extracted out by a
hydrator.

So, the work is split 50/50 - half on a basic lazy loading system for objects
and the other half on figuring out fieldsets.
