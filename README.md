# hsForms
hsForms will show a form to book hotel rooms with some predefined configurations.
# How to make it work?
- clone this repo, run `yarn install` and then `yarn build`
- Install this ext (either using ext manager or via composer)
- This ext needs jQuery, momentjs and some other libs to work. In ext configuration you can enable/disable libraries which you want to include from this ext. If you already have included those libraries then you have to uncheck the checkboxes in ext config. By default momentjs, toastr and cal (by onm) are being included. FE template is in bootstrap so including bootstrap will make modal and styles work.
- Set the storagePID where your data will be stored like travel periods, ratecodes and segments.

That's it.
# Support
- TYPO3 8 and 9 LTS
- PHP 7.x

# ToDo
- Testing on TYPO3 10
- Translate labels into Deutsche

If you find any issue please report at http://git.onm.local/typo3/hsforms or to ua@onm.de
