<template>
    <div class="card" style="height: 90vh;">
        <message-list v-model="messages"
                      :queue-position="queue_position"
                      :session-id="value"
                      :author="author"
                      :was-closed="was_closed"
                      :chatter="chatter"
                      :conversation="conversation"
                      :has-reply="has_reply"
                      :is-connected="is_connected"
                      :hide-queue-position="hideQueuePosition"></message-list>

        <div class="card-footer p-0">
            <user-input @new-message="submit"
                        :author="author"></user-input>
        </div>
    </div>
</template>

<script>
    import UserInput from './ChatWindow/UserInput.vue'
    import MessageList from './ChatWindow/MessageList.vue'

    export default {
        components: {
            UserInput,
            MessageList
        },

        props: ['value', 'hideQueuePosition', 'author'],

        data() {
            return {
                conversation: null,
                messages: collect([]),
                chatter: null,
                admin: null,
                queue_position: null,

                has_reply: false,

                was_closed: false,

                is_connected: true,

                show_chat_window: true,

                show_action_buttons: false
            }
        },

        filters : {
            setDateTime(value) {
                if (!_.isUndefined(value) && !_.isNull(value)) {
                    return moment(value).format('ll LTS');
                }
            }
        },

        mounted() {
            this.checkWebsocketConnection();

            this.getConversation();

            Echo.channel(`conversation.${this.value}`)
                .listen('NewConversationFound', (data) => {
                    this.applyEventPayload(data);
                })
                .listen('ReplySent', (data) => {
                    let message = data.payload.messages;

                    this.removeFromMessages(message.idx);
                    this.applyEventPayload(data);
                })
                .listen('QueuePositionUpdated', (data) => {
                    this.queue_position = data.queue_position;
                })
                .listen('ConversationClosed', (data) => {
                    this.$emit('closed-conversation', data.conversation);
                });
        },

        methods: {
            checkWebsocketConnection() {
                setInterval(() =>  {
                    if (Echo && Echo.connector.pusher.connection.connection !== null) {
                        this.is_connected = true;
                    } else {
                        this.is_connected = false;
                    }
                }, 1000);
            },

            getConversation() {
                axios.get(`/conversation/${this.value}/website`, {})
                    .then(({data}) => {
                        _.each(data.messages, (item, idx) => {
                            if (this.isExistingMessageIdx(item.idx)) {
                                this.messages.push({
                                    idx: item.idx,
                                    type: item.type,
                                    content: item.content,
                                    from: item.from_admin ? 'admin' : 'chatter',
                                    is_system_message: item.is_system_message,
                                    origin: 'website',
                                    is_sending: false,
                                    sent_at: item.sent_at
                                });
                            }
                        });

                        this.messageHasAdminReply();

                        this.chatter = data.chatter;
                        this.admin = data.admin;
                        this.conversation = data;

                        this.queue_position = data.queue_position;

                        this.conversation_url = data.link;
                    })
                    .catch(error => {
                    });
            },

            submit(params) {
                this.pushToMessages(params);

                console.log(params);
                axios.post(`/conversation/${this.value}/chat`, params)
                    .then(({data}) => {
                        if (data.success == false) {
                            let index = data.data.idx;
                            this.removeFromMessages(index);
                        }
                    })
                    .catch(error => {
                        if (error.response.data.errors) {
                            this.errors = error.response.data.errors;
                        }
                    });
            },

            applyEventPayload(data) {
                let message = data.payload.messages;

                let content = _.trim(message.content);

                if (!_.isEmpty(content)) {
                    let msg_idx = _.toInteger(message.idx);
                    if (this.isExistingMessageIdx(msg_idx)) {
                        this.messages.push({
                            idx: msg_idx,
                            type: message.type,
                            content: message.content,
                            from: message.from_admin ? 'admin' : 'chatter',
                            is_system_message: message.is_system_message,
                            origin: 'website',
                            is_sending: false,
                            sent_at: message.sent_at
                        });
                    }
                }

                this.chatter = data.payload.chatter;
                this.admin = data.payload.admin;
                this.conversation = data.payload;
                this.queue_position = data.payload.queue_position;
                this.was_closed = false;

                this.department_name = data.payload.concern;
                this.conversation_url = data.payload.link;

                this.messageHasAdminReply();
            },

            pushToMessages(params) {
                let content = _.trim(params.content);
                let msg_idx = _.toInteger(params.idx);

                if (!_.isEmpty(content)) {
                    this.messages.push({
                        idx: msg_idx,
                        type: params.type,
                        content: params.content,
                        from: params.from,
                        is_system_message: params.is_system_message,
                        origin: params.origin,
                        is_sending: params.is_sending
                    });
                }
            },

            removeFromMessages(idx) {
                let indexWithMessage = _.findIndex(this.messages.all(), ['idx', idx]);

                if (indexWithMessage >= 0) {
                    this.messages.splice(indexWithMessage, 1);
                }
            },

            checkForSendingMessage() {
                let message = this.messages.where('is_sending', true).first();

                if (!_.isUndefined(message)) {
                    return true;
                }

                return false;
            },

            isExistingMessageIdx(idx) {
                let mes = _.findIndex(this.messages.all(), ['idx', idx]);

                return mes == -1;
            },

            messageHasAdminReply() {
                let admin_reply = this.messages.where('from', 'admin').where('is_system_message', false).first();
                if (!_.isUndefined(admin_reply)) {
                    this.has_reply = true;
                } else {
                    this.has_reply = false;
                }
            }
        }
    }
</script>