# Laravel User Manager
User Manager based on Laravel 11, Breeze, and Spatie Permissions

## Installation
* Composer install this package first
* Run __php artisan migrate__ to create the needed tables
* Run __php artisan db:seed__, this will create a super admin user!
* Run __php artisan vendor:publish --provider="Roelvanlierop\Usermanager\UserManagerServiceProvider"__, this will load various components into Laravel.
* Run __php artisan cache:clear__ to clear cache
* Run __php artisan route:clear__ to clear route cache
* Run __php artisan view:clear__ to clear view cache

## Usage

You can use this package as any other user manager, however it makes heavy use of Spatie's permissions manager to create everything you need to secure your application including Permissions, Roles, and Teams.

## Features

* Permission management
* Role management
* Team management
* Login mirroring / Relogin as different user

## Work In Progress functionality

* Assign workflow
  * Assign role to user.
  * Assign permission to user.
  * Assign permission to role.
  * Assign role to team.
* Graphic assets to make sense of the structure.
* Invitations 
  * Redirect to home when invite is invalid.
  * Front-end notifications for invitations.
  * Broadcasting notifications with Pusher.

## Routes

* Team profile
  * /profile/team/{id?}
* Team management
  * /teams/{id?} | Team list or edit window
  * /teams/create | Create new team
  * /teams/switch/{id?} | Switch active team
* User management
  * /users/{id?} | User list or edit window
  * /users/create | Create new user
* Role management
  * /roles/{id?} | User list or edit window
  * /roles/create | Create new role
* Permission management
  * /roles/{id?} | Permission list or edit window
  * /roles/create | Create new permission
* Relogin / Login mirroring
  * /relogin/start/{id} | Login as a different user with provided ID
  * /relogin/stop | return to current user before relogin action

## Wanna help out / Support me!

Donate a fiver on KoFi to keep me hydrated and motivated! These funds will all go toward keeping development progress going and updating this package on a regular basis, adding updates, fixes, and new features in the future!

https://ko-fi.com/tharuleofficial

Thank you so much for donating and supporting this package!
