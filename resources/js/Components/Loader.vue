<template>
    <div class="full-screen d-flex justify-content-center align-content-center flex-wrap" v-if="show">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Loader",
    data: () => ({
        show: true,
    }),
    created() {
        this.emitter.on('loader', this.loader);
    },
    methods: {
        loader(show) {
            this.show = show;
        }
    }
}
</script>

<style scoped>
.full-screen {
    width: 100%;
    position: absolute;
    height: 100%;
    left: 0;
    background-color: #66666666;
    top: 0;
}
</style>
