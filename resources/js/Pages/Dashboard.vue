<template>
    <Layout>
        <template #header>
            <h2>Gestor de tareas</h2>
            <hr>
        </template>
        <template #body>
            <create-task></create-task>
            <task-list></task-list>

            <loader/>
        </template>
    </Layout>
</template>

<script>
import TaskList from '@/Components/TaskList';
import CreateTask from '@/Components/CreateTask';
import Layout from '@/Layouts/Guest';
import Loader from '@/Components/Loader';

export default {
    components: {
        Layout,
        CreateTask,
        TaskList,
        Loader,
    }
}

</script>
