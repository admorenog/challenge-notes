/**
 * The backend proxy can be used to cache requests, adapt urls or easy changes, also detach the back for future
 * changes.
 */
export default class TaskProxy {
    /**
     * @param url
     */
    constructor(url) {
        this.baseUrl = url;
        this.requestManager = axios;
        this.requestManager.interceptors.response.use(null, function (error) {
            // Here we are ready to check global errors.
            if(error.status == 422) {
                this.emitter.emit("error-unprocesable-entity", error.response.data);
            }
            return Promise.reject(error);
        });
    }

    /**
     * Returns the tasks with their categories.
     * @returns {Promise<any>}
     */
    async getTasks() {
        return (await this.requestManager.get(`${this.baseUrl}/api/tasks`)).data;
    }

    /**x
     * Create a new Task
     * @returns {Promise<any>}
     */
    async newTask(task) {
        return (await this.requestManager.post(`${this.baseUrl}/api/tasks`, task)).data;
    }

    /**
     * Removes the specified task
     * @param taskId
     * @returns {Promise<void>}
     */
    async deleteTask(taskId) {
        return (await this.requestManager.delete(`${this.baseUrl}/api/tasks/${taskId}`)).data
    }

    /**
     * List the current categories
     * @returns {Promise<void>}
     */
    async getCategories(taskId) {
        return (await this.requestManager.get(`${this.baseUrl}/api/categories`)).data
    }
}
