<template>
    <app-layout>
        <div class="flex">
            <div class="w-3/12">
                <p>Board list: </p>
                <hr>
                <hr>
                <ul id="example-1">
                    <li v-for="board in boards" :key="board.id">
                        {{ board.name }}
                        <div v-if="role.name === 'Owner' || role.name === 'Administrator'">
                            <button v-on:click="deleteBoard(board.id)">
                                X
                            </button>
                        </div>
                    </li>
                </ul>
                <hr>
                <hr>
                <inertia-link href="/board/create">
                    Add a new board
                </inertia-link>
                <hr>
                <hr>
                <p>You are this team's {{ role.name }}</p>
            </div>
            <div class="w-full bg-gray">
                THE BOARD WILL GO HERE
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