<template>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th
                v-for="header in headerTasks"
                :key="header">{{ header }}
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="task in tasks" :key="task.id">
                <td>{{ task.name }}</td>
                <td>
                    <span class="badge bg-secondary m-1" v-for="category in task.categories" :key="category">
                        {{ category.name }}
                    </span>
                </td>
                <td>
                    <button class="btn btn-flat btn-danger" @click="deleteTask(task.id)"><i class="bi-x"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: "TaskList",
    data: () => ({
        /**
         * We should install the i18n package to get a translation system or something like this, but it needs a
         * configuration and I'll focus in other features.
         */
        headerTasks : [
            "Tarea",
            "Categorías",
            "Acciones",
        ],
        tasks: []
    }),
    mounted() {
        this.emitter.on('newTask', this.newTask);
    },
    created() {
        /**
         * Here, in created we don't use the 'await' keyword because it means that will be block
         * the current thread, we will use await inside the methods to get a right secuence
         */
        this.getTasks();
    },
    methods: {
        async getTasks() {
            this.emitter.emit('loader', true);
            this.tasks = await this.taskProxy.getTasks();
            this.emitter.emit('loader', false);
        },
        async newTask(task) {
            this.tasks.push(task);
        },
        async deleteTask(taskId) {
            this.emitter.emit('loader', true);
            this.tasks = await this.taskProxy.deleteTask(taskId);
            this.emitter.emit('loader', false);
        }
    }
}
</script>
