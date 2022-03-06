<template>
    <Layout>
        <template #header>
            <h2>Gestor de tareas</h2>
        </template>
        <template #body>
            <task-list></task-list>
        </template>
    </Layout>
</template>

<script>
import TaskList from '../Components/TaskList';
import Layout from '@/Layouts/Guest';

export default {
    components: {
        Layout,
        TaskList
    }
}

</script>
