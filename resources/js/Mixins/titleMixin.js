function getTitle (vm) {
    const { title } = vm.$options;
    if (title) {
        return typeof title === 'function' ? title.call(vm) : title;
    }
}

const setTitle = () => ({
    created () {
        const title = getTitle(this);
        if (title) {
            document.title = `Geoffrey Turpin | ${title}`
        }
    }
})

export default setTitle;
