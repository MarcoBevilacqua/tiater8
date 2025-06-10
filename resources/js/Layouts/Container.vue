<template>
    <div id="container" :class="
    'py-' + this.padding +
    ' md:py-' + this.mdPadding +
    ' lg:py-' + this.lgPadding">
        <div class="max-w-7xl mx-auto md:px-8 lg:px-8">
            <FlashMessages />
            <slot />
        </div>
    </div>
</template>

<script>
import FlashMessages from "../shared/FlashMessages";

export default {
    props: {
        "padding": {
            type: Number,
            default: 4
        },
        "mdPadding": {
            type: Number,
            default: 12
        },
        "lgPadding": {
            type: Number,
            default: 12
        },
    },
    components: {
        FlashMessages,
    },
};
</script>
