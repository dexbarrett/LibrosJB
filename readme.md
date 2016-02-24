# Bookstore App

Application for selling and trading books online. 

**Tools Used**
*   Laravel 5.1
*   [Twitter Bootstrap](http://getbootstrap.com/)
*   [Laravel Socialite](https://github.com/laravel/socialite) for Social Authentication
*   [Intervention](http://image.intervention.io/) for image manipulation
*   [Dropzone](http://www.dropzonejs.com/) for uploading book photos
*   [Beanstalkd](http://kr.github.io/beanstalkd/) and [Supervisor](http://supervisord.org/) to queue email notifications
*   [Memcached](http://memcached.org/) for caching unread messages

### Demo images

__Social Login__

Regular users can sign-in using Facebook. They have a basic panel that shows conversations about a book for sale and an option to toggle email notifications when they receive a new message.

![Social Login](http://i.imgur.com/7iRMvRO.gif)


__Adding books for sale__

As for this version only admins can put books for sale and manage them. On future versions anyone will be able to. This example shows the UI to add a new book.

![Adding new books for sale](http://i.imgur.com/vLIDwH6.gif)

__Updating book information__

Admins have a dashboard that shows a list of books they have created. From here they can create new books, update the information, upload pictures of the book and change the status (for sale or not for sale). This example shows how to add comments about the book being sold.

![Update book information](http://i.imgur.com/IufpoKm.gif)

This other example shows validation. This comments field is optional but if is filled it should have at least 10 characters.

![Validations](http://i.imgur.com/eJKt4Nl.gif)

__Uploading images of the book__

It is possible to upload images of the book being sold and it will show a gallery with this images in the book's detail page. It is also possible to delete uploaded images.

![book images](http://i.imgur.com/kNqnK2S.gif)

__Changing book status__

The following example shows how to prevent a book from appearing as available by changing its status from the dashboard.

![change book status](http://i.imgur.com/xyLWH0W.gif)

__Sending messages__

From the book's detail page is possible to send a message to the seller. This will add a new entry to the list of conversations to easily navigate to the messages of each conversation.

![Send message to seller](http://i.imgur.com/2pglS83.gif)

When a user has unread messages, a notification will appear on their dropdown menu showing the number of unread messages. And the list of conversations will show a label next to each one, showing how many unread messages the user has.

When opening a conversation it will automatically scroll the page to the section where unread messages are. Unread messages will appear in red when opening a conversation.

![unread messages](http://i.imgur.com/KynjUz9.gif)

If the user has enabled notifications an email will be sent containing the message, with a direct link to the conversation.

![email notifications](http://i.imgur.com/wov9Cil.gif)