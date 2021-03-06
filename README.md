# Documentation
Create a CRUD application with php + js + html + css (frameworks allowed). The application is
about create a task manager where you can create a new task with a textbox and a few checkboxes
and a button to add. The task list should update automatically when click the add button. You
can delete a task but there is no button for edit.

![Demo](./storage/docs/demo.gif)

---
# Notes
## Design

### Tools
The opportinity is for php laravel and vue components, so I decided to develop the project using
laravel and vue components. I chose php ^8 with Laravel 9.3.1 in a docker container with
apache and another docker container with mysql 8.
The version of vue is 3 with mitt (event manager) and bootstrap 5. The XHR calls are
made with axios through a Proxy pattern design to unify the calls, but I didn't implemented a cache system, just a little blueprint for the dependency inyection principle.

### Database
The project is a task list with tags or categories associated, so we need two tables with an n-n
relation, using the laravel naming conventions the table names will be "tasks", "tags" and
"tasks_tags" to join both.

### Architecture
The project is just a simple test that can be achieved with MVC perfectly and use other
architecture will be over engineering, other designs can be a manteinance problem for this app.
The app doesn't require a system with a detached design with a message broker and is an extra
work that will not probe my capabilities.

## Considerations
- The target is checks good practices, capacities and is not asking for a login (I usually
  work with Sanctum or laravel passport, the configuration is easy, and I think that is not relevant for the test
  purposes).
- I usually work with vuetify, but it makes some components very easy to use and default Laravel
  have installed bootstrap, so I will use it.
- There is no information about ui/ux, translations or SPA, so I'll focus over other development
  features.
- I didn't make a front field validation because this will be a problem to demo the backend validations
- In the main doc talks about to use Frameworks and show my capacities and in the inner document
  just talk about php and js (using, for example, jquery). First I though use php vanilla and jquery
  but the opportunity is looking for a developer that knows how to use a framework, so I decided
  use two, front (vue.js in components like the oportunity) and backend (Laravel or Symfony).
- The inner document talks about use only one sql sentence, so even the Eloquent has methods that
  can do eager loading that makes the code cleaner. I decided to use "joins" in query builder
  to achieve the "one sentence" requirement.
- I decided to use english in the readme and code comments, even the docs are in spanish.
  The opportunity is looking for someone that can write in technical english.

### Installation
```zsh
docker-compose -f docker/docker-compose.yaml --project-directory=docker up &
docker exec -it notes_db bash
    > mysql -p
        > secret
        > create schema notes;
        > exit
    > exit
docker exec -it -u app notes_web zsh
    > nvm install 16
    > cp .env.example .env
    > composer install
    > npm i
    > composer dumpauto
    > php artisan optimize
    > php artisan migrate
    > php artisan db:seed --class=TaskCategorySeeder
    > npm run prod
```

### Tests

```
php artisan test
```
