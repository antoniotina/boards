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
     
                <inertia-link href="/board/create" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ">
                    Add a new board +
                </inertia-link>
            </div>

            <div class="w-6/12 bg-gray px-4 py-5 mt-2 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md">
                The boards will go here
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { computed } from "vue";
    import AppLayout from '@/Layouts/AppLayout'
    import { Inertia } from '@inertiajs/inertia'
    import { usePage } from "@inertiajs/inertia-vue3";

    export default {
        setup() {
            const user = computed(() => usePage().props.value.auth.user);
            const role = computed(() => usePage().props.value.auth.team.permission);

            function deleteBoard(board_id) {
                Inertia.delete('/board/' + board_id + '/destroy', board_id)
            }

            return { user, role, deleteBoard };
        },
        components: {
            AppLayout,
        },
        props: {
            team: Object,
            boards: Array,
        },
    };
</script>