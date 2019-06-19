<template>
    <div>
        <template v-if="with_conversation == true">
            <chat-window-client v-model="session_id"
                                :hide-queue-position="hideQueuePosition"
                                :author="author"
                                @closed-conversation="closedConversation"
                                @closed-conversation-by-client="closedConversationByClient"></chat-window-client>
        </template>

        <template v-else>
            <create-chatter :session-id="session_id"
                            @created-chatter="with_conversation = true"
                            v-if="session_id"></create-chatter>
        </template>
    </div>
</template>
<style scoped>
    .sc-launcher {
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
    import ChatWindowClient from './ChatWindowClient.vue'
    import CreateChatter from './Chatter/Create.vue'

    export default {
        components: {
            ChatWindowClient,
            CreateChatter
        },

        props: [
            'author',
            'hideQueuePosition'
        ],

        data() {
            return {
                session_id: null,
                with_conversation: false,
                show_chat: false
            }
        },

        mounted() {
            this.initializeChat();
        },

        methods: {
            closedConversation(data) {
                if (data.closed_by == 'chatter') {
                    this.with_conversation = false;
                }
            },

            closedConversationByClient() {
                if (this.author == 'chatter') {
                    this.with_conversation = false;
                }
            },

            initializeChat() {
                if (window.localStorage.getItem('showChat')) {
                    this.show_chat = true;
                } else {
                    this.show_chat = false;
                }

                axios.get(`/chat`, {})
                    .then(({data}) => {
                        this.session_id = data.session_id;
                        this.with_conversation = data.with_conversation;
                    })
                    .catch(error => {
                    });
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