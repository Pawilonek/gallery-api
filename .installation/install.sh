
for f in db/*.sql
do
  echo -e "\e[33mProcessing file: \e[93m$f\e[37m"
  cat "$f" | grep -e "# " | cut -c 3-
  echo -n -e "\e[39m"
  mysql --user=root --password= gallery < "$f"
  echo
done

