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
    }

    /**
     * Returns the tasks with their categories.
     * @returns {Promise<any>}
     */
    async getTasks() {
        return (await axios.get(`${this.baseUrl}/api/tasks`)).data;
    }

    /**
     * Removes the specified task
     * @param taskId
     * @returns {Promise<void>}
     */
    async deleteTask(taskId) {
        return (await axios.delete(`${this.baseUrl}/api/tasks/${taskId}`)).data
    }
}
