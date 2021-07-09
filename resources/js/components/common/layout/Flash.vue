<template>
    <div :class="'alert alert-dismissable alert-' + this.type" role="alert" v-show="show">
        <button type="button" class="close" @click="this.hide">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="pl-5">
            <strong>
                {{ body }}
            </strong>
        </div>
    </div>
</template>

<script>
export default {
    name: "Flash",
    props: ['message'],
    data() {
        return {
            show: false,
            body: '',
            type: 'success',
        }
    },
    created() {
        if (this.message) {
            this.flash(this.message)
        }
        window.events.$on('flash', (message, msgType) => this.flash(message, msgType))
    },
    methods: {
        flash(message, msgType = 'success') {
            this.show = true
            this.body = message
            this.type = msgType
            setTimeout(() => {
                this.hide()
            }, 4000)
        },
        hide() {
            this.show = false
        }
    }
}
</script>
