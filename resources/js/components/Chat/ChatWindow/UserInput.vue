<template>
    <div>
        <form class="user-input" :class="{active: inputActive}">
            <div role="button"
                 tabIndex="0"
                 @focus="setInputActive(true)"
                 @blur="setInputActive(false)"
                 @keydown="handleKey"
                 contentEditable="true"
                 placeholder="Compose your message ..."
                 class="user-input--text"
                 ref="userInput">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['author'],
        data () {
            return {
                inputActive: false
            }
        },

        methods: {
            setInputActive (value) {
                this.inputActive = value
            },

            handleKey (event) {
                if (event.keyCode === 13 && !event.shiftKey) {
                    this.submitText()
                    event.preventDefault()
                }
            },

            submitText () {
                let text = _.trim(this.$refs.userInput.textContent);
                let idx = _.toInteger(Date.now());
                if (text && text.length > 0) {
                    this.$emit('new-message', {
                        type: 'text',
                        content: text,
                        from: this.author,
                        is_system_message: false,
                        is_sending: true,
                        idx: idx
                    });

                    this.$refs.userInput.innerHTML = ''
                }
            }
        }
    }
</script>

<style>
    .user-input {
        min-height: 55px;
        margin: 0px;
        position: relative;
        bottom: 0;
        display: flex;
        /*background-color: #f4f7f9;*/
        background-color: white;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        transition: background-color 0.2s ease, box-shadow 0.2s ease;
    }

    .user-input--text {
        width: 300px;
        resize: none;
        border: none;
        outline: none;
        border-bottom-left-radius: 10px;
        box-sizing: border-box;
        padding: 18px;
        font-size: 15px;
        font-weight: 400;
        line-height: 1.33;
        white-space: pre-wrap;
        word-wrap: break-word;
        color: #565867;
        -webkit-font-smoothing: antialiased;
        max-height: 200px;
        overflow: scroll;
        bottom: 0;
        overflow-x: hidden;
        overflow-y: auto;
    }

    .user-input--text:empty:before {
        content: attr(placeholder);
        display: block; /* For Firefox */
        filter: contrast(15%);
        outline: none;
    }

    .user-input.active {
        box-shadow: none;
        background-color: white;
        box-shadow: 0px -5px 20px 0px rgba(150, 165, 190, 0.2);
    }
</style>
