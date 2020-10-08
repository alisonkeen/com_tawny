
# Election Checklist Module

This module was written for creating ACVI "christian values" pre-election checklists under Joomla 3.0. Election Checklists are a way of giving people a quick read on what the different parties' policies are on different issues to help everyone make an informed decision (and sometimes, to draw attention to issues our major parties are trying to ignore).

The ACVI has historically focused on abortion, euthanasia, gambling, freedom of religion, drug abuse, and freedom to teach our kids about our heritage as a christian country. 

This Joomla component has a  "checklist" view, and the ticks, crosses and question marks link to a "rationale" view that shows the background to each rating (past votes in parliament and public statements of policy). 


## To install: 
1. zip up the "component" folder (e.g. into a file called com_tawny.zip)
2. On a Joomla server, log in as Administrator and go to "Extensions" (top menus) and then "manage" 
3. Drag and drop the zip file into the box that says "upload & install" 

## To use: 
From memory, there should be one or two questions in a nearly-empty checklist. 

To show a checklist on the front end of the website:
1. Log in to the back end as an admin and go to "Menus" (is on the top menu bar)
2. choose Main Menu (or other menu where you want the checklist to show up)
3. Click the green "New" button to add a new menu item
4. Next to "menu item type" click the blue "select" button. 
5. Expand "Tawny Checklist" and choose "Display Checklist". 
6. Go to the second tab on the Menus:New Item screen *(the tab had a weird name last i checked, sorry... needs fixing)* and choose which state/territory you want to display a checklist for
5. Fill in "menu title" with what the link to the checklist should be called, access, target window and whether you want it as the Main Page (the first page people see when they visit your site). 
6. Then click 'Save & Close'.

you should now be able to see a menu item on your website front-end which takes you to a checklist page. 

The checklist may be empty if it hasn't been set up from the back end. As it stands, i've been adding and editing data directly from the mysql command line in dribs and drabs as i'm still learing Joomla Component coding (Need to swot up on XML form definitions, and correct coding of actions). 

This project is still pretty quick'n'dirty, I needed to get it up and running fairly quickly to give me a way to manage lots of bits of info.


# Other info that's not related to THIS component specifically... 

## Generally Helpful readmes on coding Joomla Components
How to create a view: https://www.inmotionhosting.com/support/edu/joomla-3/create-component/add-new-view

How to add a menu item: https://www.inmotionhosting.com/support/edu/joomla-3/create-component/menu-item

Adding a new task: https://www.inmotionhosting.com/support/edu/joomla-3/create-component/add-new-task

Changing 'task' for custom component:  https://forum.joomla.org/viewtopic.php?t=341566

Setting the page title from inside the component: https://joomla.stackexchange.com/questions/4317/how-can-i-set-the-page-title-from-a-component

Adding OG: and Twitter header metadata: https://www.collectiveray.com/joomla/joomla-tutorials/add-facebook-open-graph-and-twitter-cards-to-joomla.html

## Useful later for creating an API:
How to add a new output format to your Joomla Component: 
https://www.inmotionhosting.com/support/edu/joomla-3/create-component/formats

loading files with helper functions: (#include)
https://joomla.stackexchange.com/questions/15172/best-way-to-include-helper-class-in-sub-controller-require-once-or-jloader
