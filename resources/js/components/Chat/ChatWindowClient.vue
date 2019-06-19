<template>
    <div>
        <div class="sc-launcher" :class="{opened: show_chat, closed: !show_chat}" @click.prevent="onClose" style="background: #808080">
            <img class="sc-open-icon" src="../../assets/close-icon.png" />
            <img class="sc-closed-icon" src="../../assets/logo-no-bg.svg" />
        </div>
        <div class="sc-chat-window" :class="{opened: show_chat, closed: !show_chat}">
            <div class="sc-header" style="background: #212529; color: #ffffff">
                <div class="sc-header--title"> JTG MANILA CHURCH </div>
                <div class="sc-header--close-button" @click="onClose">
                    <img src="../../assets/close-icon.png" alt="" />
                </div>
            </div>
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
    </div>
</template>
<style scoped>
    .sc-launcher {
        z-index: 99999999999 !important;
        width: 60px;
        height: 60px;
        background-position: center;
        background-repeat: no-repeat;
        position: fixed;
        right: 25px;
        bottom: 25px;
        border-radius: 50%;
        box-shadow: none;
        transition: box-shadow 0.2s ease-in-out;
        cursor: pointer;
    }

    .sc-launcher:before {
        content: '';
        position: relative;
        display: block;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        transition: box-shadow 0.2s ease-in-out;
    }

    .sc-launcher .sc-open-icon,
    .sc-launcher .sc-closed-icon {
        width: 60px;
        height: 60px;
        position: fixed;
        right: 25px;
        bottom: 25px;
        transition: opacity 100ms ease-in-out, transform 100ms ease-in-out;
    }

    .sc-launcher .sc-closed-icon {
        transition: opacity 100ms ease-in-out, transform 100ms ease-in-out;
        width: 60px;
        height: 60px;
    }

    .sc-launcher .sc-open-icon {
        padding: 20px;
        box-sizing: border-box;
        opacity: 0;
    }

    .sc-launcher.opened .sc-open-icon {
        transform: rotate(-90deg);
        opacity: 1;
    }

    .sc-launcher.opened .sc-closed-icon {
        transform: rotate(-90deg);
        opacity: 0;
    }

    .sc-launcher.opened:before {
        box-shadow: 0px 0px 400px 250px rgba(148, 149, 150, 0.2);
    }

    .sc-launcher:hover {
        box-shadow: 0 0px 27px 1.5px rgba(0,0,0,0.2);
    }

    .sc-new-messsages-count {
        position: absolute;
        top: -3px;
        left: 41px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        background: #ff4646;
        color: white;
        text-align: center;
        margin: auto;
        font-size: 12px;
        font-weight: 500;
    }

    .sc-chat-window {
        z-index: 99999999999 !important;
        width: 370px;
        height: calc(100% - 120px);
        max-height: 590px;
        position: fixed;
        right: 25px;
        bottom: 100px;
        box-sizing: border-box;
        box-shadow: 0px 7px 40px 2px rgba(148, 149, 150, 0.1);
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: 0.3s ease-in-out;
        border-radius: 10px;
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
    }

    .sc-chat-window.closed {
        opacity: 0;
        visibility: hidden;
        bottom: 90px;
    }

    .sc-message--me {
        text-align: right;
    }
    .sc-message--them {
        text-align: left;
    }

    @media (max-width: 450px) {
        .sc-chat-window {
            width: 100%;
            height: 100%;
            max-height: 100%;
            right: 0px;
            bottom: 0px;
            border-radius: 0px;
        }
        .sc-chat-window {
            transition: 0.1s ease-in-out;
        }
        .sc-chat-window.closed {
            bottom: 0px;
        }
    }


    .sc-header {
        min-height: 75px;
        border-top-left-radius: 9px;
        border-top-right-radius: 9px;
        padding: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,.2);
        position: relative;
        box-sizing: border-box;
        display: flex;
    }

    .sc-header--img {
        border-radius: 50%;
        align-self: center;
        padding: 10px;
    }

    .sc-header--title {
        align-self: center;
        padding: 10px;
        flex: 1;
        user-select: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .sc-header--title:hover {
        box-shadow: 0px 2px 5px rgba(0.2, 0.2, 0.5, .1);
    }

    .sc-header--close-button {
        width: 40px;
        align-self: center;
        height: 40px;
        margin-right: 10px;
        box-sizing: border-box;
        cursor: pointer;
        border-radius: 5px;
    }

    .sc-header--close-button:hover {
        box-shadow: 0px 2px 5px rgba(0.2, 0.2, 0.5, .1);
    }

    .sc-header--close-button img {
        width: 100%;
        height: 100%;
        padding: 13px;
        box-sizing: border-box;
    }

    @media (max-width: 450px) {
        .sc-header {
            border-radius: 0px;
        }
    }

</style>

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
                show_chat: false,
                conversation: null,
                messages: collect([]),
                chatter: null,
                admin: null,
                department_name: null,
                queue_position: null,

                conversation_url: '',

                has_reply: false,

                was_closed: false,

                is_connected: true
            }
        },

        mounted() {
            if (window.localStorage.getItem('showChat')) {
                this.show_chat = true;
            } else {
                this.show_chat = false;
            }

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

                    if (data.conversation.closed_by == 'chatter') {
                        if (this.author == 'chatter') {
                            this.conversation = null;
                            this.messages = collect([]);
                            this.chatter = null;
                            this.admin = null;
                            this.queue_position = null;
                            this.was_closed = true;
                        }
                    }
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
                            let msg_idx = _.toInteger(item.idx);
                            if (this.isExistingMessageIdx(msg_idx)) {                                this.messages.push({
                                    idx: msg_idx,
                                    type: item.type,
                                    content: item.content,
                                    from: item.from_admin ? 'admin' : 'chatter',
                                    is_system_message: item.is_system_message,
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

                        this.department_name = data.department.name;
                        this.conversation_url = data.link;
                    })
                    .catch(error => {
                    });
            },

            submit(params) {
                this.pushToMessages(params);
                params['is_connected'] = this.is_connected;
                params['chatter_id'] = this.chatter.id;

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
            },

            onClose() {
                this.show_chat = !this.show_chat;

                if (this.show_chat == true) {
                    window.localStorage.setItem('showChat', '1');
                } else {
                    window.localStorage.setItem('showChat', '');
                }

            }
        }
    }
</script>