### About this App:

This is a very simple implementation of pizza delivery system design. There is an url: localhost:8000/api/initiate-system. Once we go to the url, 2 Things happen.

First it checks if any user exists or not. If there exits no user than it creates an user.

So once we have our User, Pizza Order associated with that user will be created.

Now when a first pizza order record is inserted in database, the pizza_status is set to 'Pendin'. At this point,

Our Model Observer (Observer for Pizza Model) sends that user a notification that 'Order is taken and Status Pending'

After that we fire an event to start processing the Pizza Order and set order status to 'Processing', So observer again sends the associated user that the 'Order is now at Processing State'. As Event is fired / triggered our Listener than initiate / dispatch a Job for making pizza. And the job is qued.

So observer takes action when a new recored is inserted and when a record is updated.

Our Notifications are qued in 'notification' queue.
And PizzaMakingJob is qued in 'long-process' queue as it takes 10 seconds for each pizza to be made.

So when a job is completed pizza_status in database is changed to 'Completed'. And our Observer now sends that associated user a notification that the Pizza is now Complete.

### Designs Which are Implemented

* Larave's Observer For Model.
* Event Listener
* Jobs 
* Notifications
* Multiple Queues for Notification & Long/Heavy Job.
* RabbitMq

### How to Install & Run

* Install RabbitMq (Follow Official Documentation and do all necessary things and login to rabbitmq admin panel from browser)
* Enable required extension in php.ini for RabbitMq if you are using Xampp (uncomment ;extension=amqp)
* Install MailHog
* Download or Clone the project
* In project dir, run `composer install`
* All Credentials are given in `env.exm` file, rename it to `.env`
* Once everything is installed run `php artisan serve`
* Open another CLI in project dir and run `php artisan queue:work --queue=notification,long-process`
* Now go to browser and enter `http://localhost:8000/api/initiate-system`


