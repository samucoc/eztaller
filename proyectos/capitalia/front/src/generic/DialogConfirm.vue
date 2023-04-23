<template>
    <v-dialog v-model="dialogLocal" max-width="400">
        <v-card>
            <v-card-text class="text-center pt-5">
                {{message}}
            </v-card-text>
            <v-card-actions class="justify-center">
                <v-btn depressed class="btnPrimario" text @click="accept()">
                    {{acceptText}}
                </v-btn>
                <v-btn depressed class="btnPrimario" text @click="cancel()">
                    {{cancelText}}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        name: "DialogConfirm",
        model: {
            prop: 'dialog',
            event: 'change'
        },
        props: {
            message: {
                type: String
            },
            acceptText: {
                type: String,
                default: 'Aceptar'
            },
            cancelText: {
                type: String,
                default: 'Cancelar'
            },
            dialog: Boolean
        },
        methods: {
            accept() {
                this.$emit('accept');
            },
            cancel() {
                this.$emit('change', false);
                this.$emit('cancel');
            }
        },
        computed: {
            dialogLocal: {
                get() {
                    return this.dialog;
                },
                set(newValue) {
                    this.$emit('change', newValue);
                }
            }
        }
    }
</script>

<style scoped>

</style>