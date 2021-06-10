<template>
    <app-layout>
        <div class="flex">
            <div class="w-2/12  p-2 mb-5">
                <div v-if="boards.length > 0" class="mb-3" >
                    <p class="font-bold">Boards: </p>
                    <hr>
                    <ul id="example-1">
                        <li v-for="board in boards" :key="board.id" class="flex py-2">
                            <div class="w-8/12  ">
                                {{ board.name }}
                            </div>
                            <div v-if="role.name === 'Owner' || role.name === 'Administrator'">
                                <button v-on:click="deleteBoard(board.id)" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition">
                                    X
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
                <div>
                    <vue-final-modal v-model="showModal" classes="modal-container" content-class="modal-content">
                        <div class="flex justify-center">
                            <div class="flex w-6/12 bg-gray px-4 py-5 mt-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                                <form @submit.prevent="submit(showModal)" class="modal___content">
                                    <label for="name" class="ml-3 mr-2">Name : </label>
                                    <input id="name" v-model="form.name" class="rounded-sm px-4 py-1 mt-3 mr-3 focus:outline-none bg-gray-100 " />
                                    <button type="submit" class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition'>Create</button>
                                    <div v-if="errors.name">{{ errors.name }}</div>
                                </form>
                            </div>
                        </div>
                    </vue-final-modal>
                    <button @click="showModal = true" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ">Create a new board +</button>
                </div>
            </div>

            <div class="w-6/12 bg-gray px-4 py-5 mt-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                The boards will go here
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from "@inertiajs/inertia-vue3";
    import { computed, reactive } from "vue";

    export default {
        data: () => ({
            showModal: false,
            form: {},
        }),
        setup() {
            const user = computed(() => usePage().props.value.auth.user);
            const role = computed(() => usePage().props.value.auth.team.permission);

            const form = reactive({
                name: null,
            })

            function deleteBoard(board_id) {
                Inertia.delete('/board/' + board_id + '/destroy', board_id)
            }

            return { user, role, deleteBoard, form };
        },
        methods: {
            submit() {
                Inertia.post('/board/store', this.form, {
                    onSuccess: (page) => {
                        this.showModal = false
                        this.form.name = ''
                    },
                })
            }

        },
        components: {
            AppLayout,
        },
        props: {
            team: Object,
            boards: Array,
            errors: Object,
        },
    };
</script>