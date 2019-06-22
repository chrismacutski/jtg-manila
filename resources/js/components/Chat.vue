<template>
    <div class="container-fluid pr-0 pl-0">
        <div class="row">
            <div class="col-lg-4 pr-0 overflow-auto vh-100">
                <div class="list-group list-group-flush" v-for="conversation in conversations.all()">
                    <div :class="selectedBgColor(conversation)" @click.prevent="toggle(conversation)">
                        <div class="small">
                            <b v-if="conversation">Chat ID: {{ conversation.id }}</b> <br>
                            <b>{{ conversation.chatter.nickname }}</b> <br>
                            <b>Email : </b> {{ conversation.chatter.email_address }}<br>
                            <b>Contact Number : </b> {{ conversation.chatter.phone_number }}<br>
                        </div>
                    </div>
                </div>
                <!--<button type="button" class="btn btn-primary form-control rounded-0" @click="showMore" v-text="showMoreText"></button>-->
            </div>
            <div class="col-lg-8 pl-0">
                <div class="card-group">
                    <template v-if="selectedConversation">
                        <chat-window v-model="selectedConversation"
                                     :author="author"
                                     @closed-conversation="removeFromWorkspace"></chat-window>
                    </template>

                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .pointer {
        cursor: pointer;
    }

    .bg-selected {
        background-color: #000000 !important;
    }
</style>
<script>
    import ChatWindow from '../components/Chat/ChatWindow.vue'

    export default {
        components: {
            ChatWindow
        },

        props: ['data', 'author', 'hideQueuePosition'],

        data () {
            return {
                conversations: collect([]),

                selectedConversation: null,

                showMoreText: 'Show More'
            }
        },

        mounted() {
            _.forEach(this.data, (conversation) => {
                conversation.selected = false;
                this.conversations.push(conversation);
            });

            Echo.channel(`admin-conversation`)
                .listen('NewConversationFound', (data) => {
                    console.log(data);
                    this.pushToConversations(data.payload);
                });
        },

        methods: {
            getWorkspaceData() {
                axios.get(`/admin/chats`, {})
                    .then(({data}) => {
                        this.conversations = collect(data);
                    }).catch(error => {
                        if (error.response.data.message) {
                            alert("Something went wrong!" + error.response.data.message);
                        }
                    });
            },

            removeFromWorkspace() {
                this.conversations = collect([]);

                this.$nextTick(function() {
                    this.getWorkspaceData();
                });
            },

            pushToConversations(payload) {
                let index = _.findIndex(this.conversations.all(), ['id', payload.id]);

                if (index == -1) {
                    if (this.conversations.count() < 5) {
                        this.conversations.push(payload);
                    }
                }
            },

            toggle(conversation) {
                this.selectedConversation = '';

                this.conversations.each((item, index) => {
                    if (item.selected) {
                        item.selected = false;
                    }
                });

                this.$nextTick(() => {
                    this.selectedConversation = conversation.session_id;
                    conversation.selected = !conversation.selected;
                })
            },

            selectedBgColor(conversation) {
                console.log(conversation);
                if (conversation.selected == false) {
                    return 'list-group-item pointer'
                }

                return 'list-group-item bg-selected text-white'
            },

            showMore() {

            }
        }
    }
</script>