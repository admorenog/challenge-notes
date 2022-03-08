<template>
    <div class="mt-2 input-group">
        <input type="text" class="form-control" :class="errors.name?'is-invalid':''" v-model="task.name" @input="errors={}"/>
        <span class="input-group-text" ref="categories">
            <span
                v-for="category in categories" :key="category.id"
                class="input-group">
                <div class="input-group-text">
                    <input
                    :value="category.id"
                    v-model="task.categories"
                    class="form-check-input mt-0"
                    type="checkbox"/>
                </div>
                <label class="form-control"
                :for="category.name">{{ category.name }}</label>
            </span>
        </span>
        <button
        class="input-group-text btn btn-success"
        @click="addTask"
        >Añadir</button>
        <div class="invalid-feedback" v-for="(error, name) in errors.name" :key="name">
            {{ error }}
        </div>
    </div>
</template>

<script>
export default {
    name: "CreateTask",
    data: () => ({
        categories: [],
        task: {
            name: "",
            categories: []
        },
        errors: {}
    }),
    created() {
        this.getCategories();
    },
    methods: {
        async getCategories() {
            this.categories = await this.taskProxy.getCategories();
        },
        async addTask() {
            this.emitter.emit('loader', true);
            try {
                let task = await this.taskProxy.newTask(this.task);
                this.emitter.emit('newTask', task);
                this.emitter.emit('loader', false);
            }
            catch(error) {
                this.errors = error.response.data.errors;
                this.emitter.emit('loader', false);
            }
        }
    }
}
</script>
