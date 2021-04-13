<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                <jet-application-logo class="block h-12 w-auto" />
            </div>

            <div class="mt-8 text-2xl">
                Welcome to Boards!
            </div>

            <div class="mt-6 text-gray-500">
                Start with a Board with lists and tasks. 
                Personalize and add other functionalities as the project evolves and your team grows. 
                Manage projects, organize tasks and develop a team spirit all in the same place.
            </div>
        </div>
    </div>
</template>

<script>
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo'

    export default {
        components: {
            JetApplicationLogo,
        },
    }
</script>
