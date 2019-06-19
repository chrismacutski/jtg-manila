<template>
    <div class="card" style="height: 90vh;">
        <template v-if="show_chat_window">
            <template v-if="customer">
                <div class="card-header bg-dark text-white">
                    <div class="small text-center">
                        {{ conversation.received_at | setDateTime }}
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="small">
                            <b v-if="conversation">Chat ID: {{ conversation.id }}</b> <br>
                            <button @click="show_chat_window = false" type="button" class="btn btn-sm text-primary p-0">
                                <i class="fa fa-pencil"></i>
                                <b>{{ customer.nickname }}</b>
                            </button> <br>
                            <b>{{ campaignLabel }} : {{ customer.identifier }}</b> <br>
                            <b>Email : </b> {{ customer.email_address }}<br>
                            <b>Contact Number : </b> {{ customer.phone_number }}<br>
                            <b>Location : </b> {{ customer.location }}<br>
                            <b>Concern : </b> {{ department_name }}<br>
                            <b>Sent Transcript of Conversation : </b> {{ conversation.times_transcript_was_sent | transcriptWasSent }}<br>
                        </div>
                        <close-conversation :conversation="conversation"
                                            :agent="agent"></close-conversation>
                    </div>

                    <template v-if="show_action_buttons">
                        <div class="d-flex justify-content-between">
                            <!--<create-crm-interaction :conversation="conversation"-->
                                                    <!--:agent="agent"></create-crm-interaction>-->

                            <email-transcript :conversation="conversation"
                                              :agent="agent"></email-transcript>
                        </div>
                    </template>
                    <template v-else>
                        <div class="d-flex justify-content-end">
                            <button @click="show_action_buttons = true" type="button" class="btn btn-sm btn-primary pt-0 pb-0 pr-3 pl-3">
                                <h5 class="text-center">...</h5>
                            </button>
                        </div>
                    </template>
                </div>
            </template>
            <message-list v-model="messages"
                          :queue-position="queue_position"
                          :session-id="value"
                          :author="author"
                          :campaign-name="campaignName"
                          :campaign-label="campaignLabel"
                          :was-closed="was_closed"
                          :customer="customer"
                          :department-name="department_name"
                          :conversation="conversation"
                          :has-agent-reply="has_agent_reply"
                          :is-connected="is_connected"
                          :hide-queue-position="hideQueuePosition"></message-list>

            <div class="card-footer p-0">
                <user-input @new-message="submit"
                            :author="author"
                            :origin="origin"></user-input>
            </div>
        </template>
        <template v-else>
            <div class="card-header bg-dark text-white">
                <div class="d-flex justify-content-between">
                    <span>Edit Customer Details</span>
                </div>
            </div>
            <div class="card-body overflow-auto d-flex flex-column">
                <customer-edit :data="customer"
                               :session-id="value"
                               :campaign-label="campaignLabel"
                               :should-require-concern="false"
                               @updated-customer="updateCustomerDetails"
                               @back-to-chat="show_chat_window = true"></customer-edit>
            </div>
        </template>
    </div>
</template>

<script>
    import UserInput from './Chat/ChatWindow/UserInput.vue'
    import MessageList from './Chat/ChatWindow/MessageList.vue'
    import CloseConversation from '../components/Conversation/Close.vue'
    import CreateCrmInteraction from '../components/CRM/CreateInteraction.vue'
    import EmailTranscript from '../components/Transcript/SendToEmail.vue'
    import CustomerEdit from './Chat/Customer/Edit.vue'

    export default {
        components: {
            UserInput,
            MessageList,
            CloseConversation,
            CreateCrmInteraction,
            EmailTranscript,
            CustomerEdit
        },

        props: ['value', 'campaignName', 'campaignLabel', 'hideQueuePosition', 'author', 'origin'],

        data() {
            return {
                conversation: null,
                messages: collect([]),
                customer: null,
                agent: null,
                department_name: null,
                queue_position: null,

                conversation_url: '',

                has_agent_reply: false,

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
            },

            transcriptWasSent(value) {
                if (value > 0) {
                    return "Yes";
                }

                return "No";
            }
        },

        mounted() {
            this.checkWebsocketConnection();

            this.getConversation();

            Echo.channel(`conversation.${this.value}`)
                .listen('NewConversationFound', (data) => {
                    this.applyEventPayload(data);
                })
                .listen('ConversationAssigned', (data) => {
                    let message = data.payload.messages;

                    this.removeFromMessages(message.idx);
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
                                    from: item.from_agent ? 'agent' : 'client',
                                    is_system_message: item.is_system_message,
                                    origin: 'website',
                                    is_sending: false,
                                    sent_at: item.sent_at
                                });
                            }
                        });

                        this.messageHasAgentReply();

                        this.customer = data.customer;
                        this.agent = data.agent;
                        this.conversation = data;

                        this.queue_position = data.queue_position;

                        this.department_name = data.department.name;
                        this.conversation_url = data.link;
                    })
                    .catch(error => {
                    });
            },

            submit(params) {
                params['idx'] = this.pushToMessages(params);

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
                    if (this.isExistingMessageIdx(message.idx)) {
                        this.messages.push({
                            idx: message.idx,
                            type: message.type,
                            content: message.content,
                            from: message.from_agent ? 'agent' : 'client',
                            is_system_message: message.is_system_message,
                            origin: 'website',
                            is_sending: false,
                            sent_at: message.sent_at
                        });
                    }
                }

                this.customer = data.payload.customer;
                this.agent = data.payload.agent;
                this.conversation = data.payload;
                this.queue_position = data.payload.queue_position;
                this.was_closed = false;

                this.department_name = data.payload.concern;
                this.conversation_url = data.payload.link;

                this.messageHasAgentReply();
            },

            pushToMessages(params) {
                let last_message = this.messages.last();
                let last_message_index = 0;
                if (!_.isUndefined(last_message)) {
                    last_message_index = last_message.idx + 1;
                }

                let content = _.trim(params.content);

                if (!_.isEmpty(content)) {
                    this.messages.push({
                        idx: last_message_index,
                        type: params.type,
                        content: params.content,
                        from: params.from,
                        is_system_message: params.is_system_message,
                        origin: params.origin,
                        is_sending: params.is_sending
                    });
                }

                return last_message_index;
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

            messageHasAgentReply() {
                let agent_reply = this.messages.where('from', 'agent').where('is_system_message', false).first();
                if (!_.isUndefined(agent_reply)) {
                    this.has_agent_reply = true;
                } else {
                    this.has_agent_reply = false;
                }
            },

            updateCustomerDetails(data) {
                this.customer = data;
                this.show_chat_window = true;
            }
        }
    }
</script>