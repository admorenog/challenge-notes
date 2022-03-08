<template>
    <head>
        <title>Dashboard</title>
    </head>
    <body>
        <div class="container-fluid col-md-8 mt-5">
            <slot name="header" />
            <slot name="body" />
        </div>
    </body>
</template>
