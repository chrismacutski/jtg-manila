<template>
    <div class="card-body overflow-auto d-flex flex-column" ref="scrollList">
        <template v-for="message in value.sortBy('idx').all()">
            <message :message="message"
                     :author="author"
                     :is-connected="isConnected"></message>
        </template>
        <queue-position v-if="queuePosition > 0 && !hideQueuePosition" :position="queuePosition"></queue-position>

        <template v-if="author == 'admin' && chatter">
            <div class="alert alert-danger text-dark mt-2" v-if="!hasReply">
                <span class="font-weight-bold">Please reply</span>
            </div>
        </template>

        <template v-if="!isConnected">
            <p class="mt-auto mb-0 small text-danger text-center">Connection is not established, you may try to refresh the page</p>
        </template>
    </div>
</template>

<script>
    import Message from './Message.vue'
    import QueuePosition from './QueuePosition.vue'

    export default {
        components: {
            Message,
            QueuePosition
        },

        props: [
            'value',
            'queuePosition',
            'sessionId',
            'author',
            'wasClosed',
            'chatter',
            'conversation',
            'hasReply',
            'isConnected',
            'hideQueuePosition'
        ],

        data() {
            return {
            }
        },

        mounted() {
            this.$nextTick(this.scrollDown())
        },

        updated () {
            this.$nextTick(this.scrollDown())
        },

        methods: {
            scrollDown() {
                this.$refs.scrollList.scrollTop = this.$refs.scrollList.scrollHeight;
            }
        }
    }
</script>