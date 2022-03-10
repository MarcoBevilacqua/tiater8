<template>
    <div class="py-4 md:py-12 lg:py-12">
        <div class="max-w-7xl mx-auto md:px-8 lg:px-8">
            <FlashMessages />
            <slot />
        </div>
    </div>
</template>

<script>
import FlashMessages from "../shared/FlashMessages";

export default {
    components: {
        FlashMessages,
    },
};
</script>
