Time for a long-overdue writeup, and a constant WIP at that.

The idea is relatively simple, the user can create their own 'slide' for teaching purposes, so students can idly sit on their phones and use the app. A 'slide' will contain a question and image with up to four options, and the student has to select the right answer. 
An example question would be "select the liver", on an image of a human anatomy. There'll be two separate versions, desktop and mobile. Desktop will primarily be used by admins (teachers creating content) and the mobile version by students, though there'll be a desktop student version too.
Different permissions will dictate what can/cannot be seen by any given logged in account. E.g. teachers & students will have very different dashboards, and students will not have access to slide creation.

### Core components of the app:
- Login & auth
- Dashboard
- 'Play'
- Properties upload
- Slide creation


### Login & Auth
This will be handled by Laravel Breeze, OOTB. Some minor adjustments may be made, but not immediately.

### Dashboard
Different views for students & teachers. Students will have a highscores, and some sort of progress tracker. Teachers will have access to all their student's data.

### Play
This will be the (hopefully) most used part of the application. Students will be able to play the game, possibly with a limit of questions per day, depending on how I decide on the gamification.

### Properties Upload
Accessible to teachers, properties for a slide can be uploaded, and fall under the following categories:
- Question, essentially the header for a slide, e.g. "Select the liver."
- Image, the picture that will be able to be interacted with by the student. In the above example, it could be a diagram of human anatomy.
- Option, selectable options. Not bound to any particular image/question, though a `slide_option` will be created when an option is selected for a `slide`, but more of that later. Choosing to have these decoupled as the same option may well come up several times across different images.

### Slide Creation
Accessible to teachers, a `slide` can be created and consists of a question, image and up to four options. On creation the teacher will select a question from the dropdown, and four possible answers as options. They can then designate which one is correct, and draw a region on the image to have as the clickable area.

_Currently having a bit of trouble with the region drawing for slide creation. It's proving complicated, so may first have a simplified version where the teachers upload a 'selected' image, e.g. anatomy with the liver highlighed, and the question ends up being a simple 'What is this?' This will enable me to crack on and develop things like highscores sooner, rather than getting stuck for ages behind a single piece of functionality._


