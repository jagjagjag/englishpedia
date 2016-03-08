#!/bin/sh

# 一時ファイル、削除ファイルを削除
tmpdir='/var/www/engp/html/wordpress/wp-content/themes/engp/review_photo/tmp'
deldir='/var/www/engp/html/wordpress/wp-content/themes/engp/review_photo/delete'
logfile=/var/www/engp/html/wordpress/wp-content/themes/engp/review_photo/filedelete.log

# ファイル削除(期間)
# find -mtime 最後にデータが修正された日時で検索する
# -1(1日(24時間)前?現在 )
# 1(1日(24時間)前?2日(96時間)前)
# +1(1日(24時間)前?過去)

echo "START -> `date '+%Y/%m/%d %T'`" >> ${logfile}

cd ${tmpdir}
for tmpfile in `find ${tmpdir} -mtime +1`; do
    # ここで一時ファイル削除
    echo "DEL -> `stat -c '%y' "${tmpfile}"` "${tmpfile}"" >> ${logfile}
    rm -f "${tmpfile}"
done

cd ${deldir}
for delfile in `find ${deldir} -mtime +7`; do
    # ここで削除ファイル削除
    echo "DEL -> `stat -c '%y' "${delfile}"` "${delfile}"" >> ${logfile}
    rm -f "${delfile}"
done

echo "END -> `date '+%Y/%m/%d %T'`" >> ${logfile}
