<template>
    <div>
        <app-layout>
            <div class="flex">
                <div class="w-2/12  p-2 mb-5">
                    <div v-show="boards.length > 0" class="mb-3" >
                        <p class="font-bold">Boards: </p>
                        <hr>
                        <ul id="example-1">
                            <li v-for="board in boards" :key="board.id" class="flex py-2">
                                <div class="w-8/12" @click="showBoard(board.id)">
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
                    <div v-if="loadingBoard">
                        ...
                    </div>
                    <div v-else>
                        <Board v-if="showBoardBool && currentBoard" :board="currentBoard" :user="user" :permission="team.permission" />
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Board from '@/Pages/Boards/Board'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from "@inertiajs/inertia-vue3";
    import { computed, reactive, toRefs } from "vue";

    export default {
        setup() {
            const user = computed(() => usePage().props.value.auth.user);
            const role = computed(() => usePage().props.value.auth.team.permission);

            const state = reactive({
                form: {
                    name: null,
                },
                showModal: false,
                showBoardBool: false,
                currentBoard: [],
                loadingBoard: false,
            })

            const submit = () => {
                Inertia.post('/board/store', state.form, {
                    onSuccess: (page) => {
                        state.showModal = false
                        state.form.name = ''
                    },
                })
            };

            const deleteBoard = (board_id) => {
                confirm('Are you sure you want to delete this board?') 
                    ? Inertia.delete('/board/' + board_id + '/destroy', board_id)
                    : null
            };

            const showBoard = async (boardId) => {
                state.showBoardBool = true
                state.loadingBoard = true

                await axios.get('/board/' + boardId)
                    .then(res => {
                        state.loadingBoard = false
                        state.currentBoard = res.data[0]
                    })
            };

            return { user, role, submit, deleteBoard, showBoard, ...toRefs(state) };
        },
        components: {
            AppLayout,
            Board,
        },
        props: {
            team: Object,
            boards: Array,
            errors: Object,
        },
    };
</script>