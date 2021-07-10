<template>
    <div class="alert alert-flash alert-success" role="alert" v-show="show">
        <strong>Success: </strong> {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: '',
                show: false
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }
            
            window.addEventListener('flash', event => this.flash(event.detail));
        },
        methods: {
            flash(message) {
                this.body = message;
                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000);
            }
        }
    }
</script>

<style scoped>
    .alert-flash {
        position: fixed;
        right: 20px;
        bottom: 20px;
    }
</style>
